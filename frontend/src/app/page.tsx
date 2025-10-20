"use client";

import { Header } from "@/components/Header";
import { OnboardContainer } from "@/components/OnboardContainer";

export default function Home() {
    return (
        <div className="flex flex-col gap-36
        GeneralPurposeBg min-h-screen ">
            <Header/>
            <OnboardContainer />
        </div>
    )
}